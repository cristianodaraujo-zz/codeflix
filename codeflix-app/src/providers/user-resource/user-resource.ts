import {Injectable} from '@angular/core';
import {Headers, Http, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/map';
import {EnvVars} from "../../models/env-vars.i";
import "rxjs/add/operator/toPromise";
import {AuthHttp} from "angular2-jwt";
import {Observable} from "rxjs/Observable";

declare var ENV: EnvVars;

/*
  Generated class for the UserResourceProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class UserResourceProvider {

    constructor(public http: Http, public authHttp: AuthHttp) {
        console.log('Hello UserResourceProvider Provider');
    }

    register(accessToken: string): Promise<string> {
        let headers = new Headers();

        headers.set('Authorization', `bearer ${accessToken}`);

        return this.http.post(`${ENV.API_URL}/register`, {}, new RequestOptions({
            headers
        })).toPromise().then(response => response.json().token);
    }

    changePassword({password, password_confirmation}): Promise<Object> {
        return this.authHttp.patch(`${ENV.API_URL}/user/change-password`, {
            password,
            password_confirmation
        }).toPromise().then(response => response.json().user);
    }

    addCpf(cpf: string): Promise<Object> {
        return this.authHttp.patch(`${ENV.API_URL}/user/cpf`, {
            cpf
        }).toPromise().then(response => response.json().user);
    }

    get(): Observable<Object> {
        return this.authHttp.get(`${ENV.API_URL}/user`)
            .map(response => response.json().user);
    }

    subscriptions(): Observable<Object> {
        return this.authHttp.get(`${ENV.API_URL}/subscriptions`)
            .map(response => response.json().subscriptions);
    }
}
