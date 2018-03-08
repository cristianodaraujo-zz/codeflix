import {Component} from '@angular/core';
import {IonicPage, MenuController, NavController, NavParams, ToastController} from 'ionic-angular';
import "rxjs/add/operator/toPromise";
import {AuthProvider} from "../../providers/auth/auth";

/**
 * Generated class for the LoginPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@IonicPage()
@Component({
    selector: 'page-login',
    templateUrl: 'login.html',
})
export class LoginPage {

    user = {
        email: 'admin@user.com',
        password: 'secret'
    };

    constructor(public navCtrl: NavController,
                public menuCtrl: MenuController,
                public toastCtrl: ToastController,
                public navParams: NavParams,
                private auth: AuthProvider
                //private jwtClient: JwtClientProvider
    ) {
        this.menuCtrl.enable(false);
    }

    ionViewDidLoad() {
        console.log('ionViewDidLoad LoginPage');
    }

    login() {
        this.auth.setLogin(this.user).then((user) => {
            this.accessAllowed(user);
        }).catch(() => {
            this.toastCtrlPresent('E-mail e/ou senha inválidos.');
        });
        /*this.jwtClient.accessToken({
            email: this.email, password: this.password
        }).then((token) => {
            console.log(token);
        });*/
    }

    loginFacebook() {
        this.auth.loginFacebook().then((user) => {
            this.accessAllowed(user);
        }).catch(() => {
            this.toastCtrlPresent('Falha ao logar com o Facebook.');
        });
    }

    accessAllowed(user) {
        this.menuCtrl.enable(true);
        this.navCtrl.setRoot(user.subscriber ? 'Subscriber' : 'Home');
    }

    toastCtrlPresent(message: string) {
        return this.toastCtrl.create({
            message: message,
            duration: 5000,
            position: 'bottom',
            cssClass: 'toast-error'
        }).present();
    }

}
