import {Injectable} from '@angular/core';
import {BrowserXhr, Request, Response, ResponseOptions, XHRBackend, XHRConnection, XSRFStrategy} from '@angular/http';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/throw';
import {Observable} from "rxjs/Observable";
import {appContainer} from "../../app/app.container";
import {JwtClientProvider} from "../jwt-client/jwt-client";
import {RedirectorProvider} from "../redirector/redirector";

/*
  Generated class for the XhrBackendProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class XhrBackendProvider extends XHRBackend {

    constructor(browserXHR: BrowserXhr, baseResponseOptions: ResponseOptions, xsrfStrategy: XSRFStrategy) {
        super(browserXHR, baseResponseOptions, xsrfStrategy);
    }

    createConnection(request: Request): XHRConnection {
        let xhrConnection = super.createConnection(request);

        xhrConnection.response = xhrConnection.response.map((response) => {
            this.tokenSetter(response);

            return response;
        }).catch((error) => {
            this.responseError(error);

            return Observable.throw(error);
        });

        return xhrConnection;
    }

    tokenSetter(response: Response) {
        let jwtClient = appContainer().get(JwtClientProvider);

        if (response.headers.has('Authorization')) {
            let authorization = response.headers.get('Authorization');
            let token = authorization.replace('bearer ', '');

            jwtClient.setToken(token);
        }
    }

    responseError(response: Response) {
        let redirector = appContainer().get(RedirectorProvider);

        switch (response.status) {
            case 401:
                redirector.next();
                break;
            case 403:
                let data = response.json();

                if (data.hasOwnProperty('error') && data.error == "subscription_valid_not_found") {
                    redirector.next('Home');
                } else {
                    redirector.next('Login');
                }
                break;
        }
    }
}
