import {Injectable} from '@angular/core';
import 'rxjs/add/operator/map';
import {JwtClientProvider} from "../jwt-client/jwt-client";
import {JwtPayload} from "../../models/jwt-payload.i";
import {Facebook, FacebookLoginResponse} from "@ionic-native/facebook";
import {UserResourceProvider} from "../user-resource/user-resource";
import {BehaviorSubject} from "rxjs/BehaviorSubject";

/*
  Generated class for the AuthProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class AuthProvider {

    private user: any = null;
    private userSubject: any = new BehaviorSubject(null);

    constructor(public jwtClient: JwtClientProvider, public facebook: Facebook, public userResource: UserResourceProvider) {
        /*this.getUser().then((user) => {
            console.log(user);
        });*/
    }

    getUser(): Promise<Object> {
        return new Promise((resolve) => {
            if (this.user) {
                resolve(this.user);
            }
            this.jwtClient.getPayload().then((payload: JwtPayload) => {
                if (payload) {
                    this.user = payload.user;
                    this.userSubject.next(this.user);
                }
                resolve(this.user);
            });
        })
    }

    getUserSubject(): BehaviorSubject<Object> {
        return this.userSubject;
    }

    setLogin({email, password}): Promise<Object> {
        return this.jwtClient.accessToken({email, password}).then(() => {
            return this.getUser();
        });
    }

    setLogout() {
        return this.jwtClient.revokeToken().then(() => {
            this.user = null;
        });
    }

    checked(): Promise<boolean> {
        return this.getUser().then((user) => {
            return  user !== null;
        });
    }

    loginFacebook(): Promise<Object> {
        return this.facebook.login(['email']).then((response: FacebookLoginResponse) => {
            return this.userResource.register(response.authResponse.accessToken).then((token) => {
                this.jwtClient.setToken(token);
                return this.getUser()
            })
        })
    }
}
