import {Component} from '@angular/core';
import {IonicPage, NavController, ToastController} from 'ionic-angular';
import {UserResourceProvider} from "../../providers/user-resource/user-resource";

/**
 * Generated class for the AddCpfPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@IonicPage()
@Component({
    selector: 'page-add-cpf',
    templateUrl: 'add-cpf.html',
})
export class AddCpfPage {
    cpf: string = null;
    mask = [
        /\d/, /\d/, /\d/, '.',
        /\d/, /\d/, /\d/, '.',
        /\d/, /\d/, /\d/, '-',
        /\d/, /\d/
    ];

    constructor(
        public navCtrl: NavController,
        public toastCtrl: ToastController,
        public userResource: UserResourceProvider) {
    }

    ionViewDidLoad() {
        console.log('ionViewDidLoad AddCpfPage');
    }

    submit() {
        this.userResource.addCpf(this.cpf).then(() => {
            this.navCtrl.push('Plans');
        }).catch(() => {
            this.toastCtrl.create({
                message: 'CPF inválido! Verifique novamente.',
                duration: 3000,
                position: 'bottom',
                cssClass: 'toast-error'
            }).present();
        });
    }

}
