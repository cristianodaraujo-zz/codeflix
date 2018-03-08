import {Component} from '@angular/core';
import {IonicPage, LoadingController, NavController, NavParams} from 'ionic-angular';
import {Auth} from "../../decorators/auth.decorators";
import {UserResourceProvider} from "../../providers/user-resource/user-resource";

/**
 * Generated class for the SignaturePage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@Auth()
@IonicPage()
@Component({
    selector: 'page-signature',
    templateUrl: 'signature.html',
})
export class SignaturePage {
    subscriptions: any = null;

    constructor(public navCtrl: NavController,
                public navParams: NavParams,
                public loadingCtrl: LoadingController,
                public userResource: UserResourceProvider) {
    }

    ionViewDidLoad() {
        let loading = this.loadingCtrl.create({
            content: 'Carregando...'
        });
        loading.present();

        this.subscriptions = this.userResource.subscriptions().map((subscriptions) => {
            loading.dismiss();
            return subscriptions;
        });
    }

}
