import {Component} from '@angular/core';
import {IonicPage, NavController, NavParams} from 'ionic-angular';
import {AuthHttp} from "angular2-jwt";

/**
 * Generated class for the SubscriberPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

//@Auth()
@IonicPage()
@Component({
    selector: 'page-subscriber',
    templateUrl: 'subscriber.html',
})
export class SubscriberPage {

    constructor(public navCtrl: NavController, public navParams: NavParams, public authHttp: AuthHttp) {
    }

    ionViewDidLoad() {
        this.authHttp.get('http://localhost:8080/api/test').toPromise().then(() => {
            console.log('testet');
        });
    }

}
