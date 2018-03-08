import {Injectable} from '@angular/core';
import 'rxjs/add/operator/map';
import {Subject} from "rxjs/Subject";
import {NavController} from "ionic-angular";

/*
  Generated class for the RedirectorProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class RedirectorProvider {
    link: string = null;
    subject = new Subject;

    config(navCtrl: NavController) {
        this.subject.subscribe(() => {
            setTimeout(() => {
                navCtrl.setRoot(this.link);
            })
        })
    }

    next(link = 'Login') {
        this.link = link;
        this.subject.next();
    }
}
