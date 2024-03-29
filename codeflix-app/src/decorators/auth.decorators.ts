import {appContainer} from "../app/app.container";
import {AuthProvider} from "../providers/auth/auth";
import {Nav} from "ionic-angular";
import {LoginPage} from "../pages/login/login";

export const Auth = () => {
    return (target: any) => {
        target.prototype.ionViewCanEnter = function () {
            let property = Object.keys(this).find(value => this[value] instanceof Nav);
            let authProvider = appContainer().get(AuthProvider);

            if (typeof property === "undefined") {
                setTimeout(() => {
                    throw new TypeError("Auth decorator needs NavController instance.");
                });
            }

            return authProvider.checked().then((isLogged) => {
                if (! isLogged) {
                    setTimeout(() => {
                        this[property].setRoot(LoginPage);
                    });

                    return false;
                }

                return true;
            });
        }
    }
};