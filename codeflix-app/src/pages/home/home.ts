import {Component} from '@angular/core';
import {NavController} from 'ionic-angular';
import {Auth} from "../../decorators/auth.decorators";
import {Http} from "@angular/http";
import "rxjs/add/operator/toPromise";

@Auth()
@Component({
    selector: 'page-home',
    templateUrl: 'home.html'
})
export class HomePage {

    constructor(public navCtrl: NavController, public authHttp: Http) {

    }

    ionViewDidLoad() {
        /*this.authHttp.get('http://localhost:8080/api/user').toPromise().then(() => {
            console.log('ppp');
        })*/
    }

}
