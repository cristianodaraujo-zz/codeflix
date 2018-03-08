import {Component} from '@angular/core';
import {IonicPage, NavController, ToastController} from 'ionic-angular';
import {Auth} from "../../decorators/auth.decorators";
import {UserResourceProvider} from "../../providers/user-resource/user-resource";

/**
 * Generated class for the ChangePasswordPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@Auth()
@IonicPage()
@Component({
    selector: 'page-change-password',
    templateUrl: 'change-password.html',
})
export class ChangePasswordPage {

    user = {
        password: '',
        password_confirmation: ''
    };

    constructor(
        public navCtrl: NavController,
        public toastCtrl: ToastController,
        public userResource: UserResourceProvider) {
    }

    ionViewDidLoad() {
        console.log('ionViewDidLoad ChangePasswordPage');
    }

    toSend() {
        this.userResource.changePassword(this.user).then(() => {
            this.toastCtrlPresent('Senha alterada com sucesso.', 'toast-success');
        }).catch(() => {
            this.toastCtrlPresent('Falha na alteração da senha.', 'toast-error');
        })
    }

    toastCtrlPresent(message: string, cssClass: string) {
        return this.toastCtrl.create({
            message: message,
            duration: 5000,
            position: 'bottom',
            cssClass: cssClass
        }).present();
    }
}
