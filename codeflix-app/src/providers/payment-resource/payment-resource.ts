import {Injectable} from '@angular/core';
import 'rxjs/add/operator/map';
import {Observable} from "rxjs/Observable";
import {EnvVars} from "../../models/env-vars.i";
import {AuthHttp} from "angular2-jwt";

declare var ENV: EnvVars;

/*
  Generated class for the PaymentResourceProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class PaymentResourceProvider {

    constructor(public authHttp: AuthHttp) {
        console.log('Hello PaymentResourceProvider Provider');
    }

    get(planId: number): Observable<Object> {
        return this.authHttp.post(`${ENV.API_URL}/plans/${planId}/payments`, {})
            .map(response => response.json());
    }

    does(planId: number, paymentId: string, payerId: string): Observable<Object> {
        return this.authHttp.patch(`${ENV.API_URL}/plans/${planId}/payments`, {
            payment_id: paymentId,
            payer_id: payerId
        }).map(response => response.json());
    }

}
