import {Injectable} from '@angular/core';
import {Headers, RequestOptions} from '@angular/http';
import 'rxjs/add/operator/map';
import {JwtCredentials} from "../../models/jwt-credentials.i";
import {Storage} from "@ionic/storage";
import {AuthHttp, JwtHelper} from "angular2-jwt";
import {EnvVars} from "../../models/env-vars.i";

declare var ENV: EnvVars;

/**
  Generated class for the JwtClientProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class JwtClientProvider {

    private token: string = null;
    private payload: string = null;

    constructor(public authHttp: AuthHttp, public storage: Storage, public jwtHelper: JwtHelper) {
        this.getToken();
        /*this.getPayload().then((payload) => {
            console.log(payload);
        });*/
    }

    getToken(): Promise<string> {
        return new Promise((resolve) => {
            if (this.token) {
                resolve(this.token);
            }
            this.storage.get(ENV.TOKEN_NAME).then((token) => {
                this.token = token;
                resolve(this.token);
            });
        })
    }

    getPayload(): Promise<Object> {
        return new Promise((resolve) => {
            if (this.payload) {
                resolve(this.payload);
            }
            this.getToken().then((token) => {
                if (token) {
                    this.payload = this.jwtHelper.decodeToken(token);
                }
                resolve(this.payload);
            });
        })
    }

    accessToken(jwtCredentials: JwtCredentials): Promise<string> {
        return this.authHttp.post(`${ENV.API_URL}/access-token`, jwtCredentials).toPromise().then((response) => {
            this.storage.set(
                ENV.TOKEN_NAME,
                this.token = response.json().token
            );

            return this.token;
        });
    }

    revokeToken(): Promise<null> {
        let headers = new Headers();
            headers.set('Authorization', `bearer ${this.token}`);
        let requestOptions = new RequestOptions({headers});

        return this.authHttp.post(`${ENV.API_URL}/logout`, {}, requestOptions).toPromise().then(() => {
            this.token = null;
            this.payload = null;
            this.storage.remove(ENV.TOKEN_NAME);

            return null;
        });
    }

    setToken(token: string): string {
        this.token = token;
        this.storage.set(ENV.TOKEN_NAME, this.token);

        return this.token;
    }
}
