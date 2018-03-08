import {Component} from '@angular/core';
import {IonicPage, LoadingController, NavController, NavParams} from 'ionic-angular';
import {PlanResourceProvider} from "../../providers/plan-resource/plan-resource";
import {Auth} from "../../decorators/auth.decorators";
import {Observable} from "rxjs/Observable";

/**
 * Generated class for the PlansPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@Auth()
@IonicPage()
@Component({
    selector: 'page-plans',
    templateUrl: 'plans.html',
})
export class PlansPage {
    plans: Observable<Array<Object>>;

    constructor(
        public navCtrl: NavController,
        public navParams: NavParams,
        public loadingCtrl: LoadingController,
        public planResource: PlanResourceProvider) {
    }

    ionViewDidLoad() {
        let loading = this.loadingCtrl.create({
            content: 'Carregando...'
        });
        loading.present();

        this.plans = this.planResource.all().map((plans) => {
            loading.dismiss();
            return plans;
        });
    }

}
