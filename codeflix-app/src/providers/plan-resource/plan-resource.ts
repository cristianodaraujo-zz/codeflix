import {Injectable} from '@angular/core';
import 'rxjs/add/operator/map';
import {AuthHttp} from "angular2-jwt";
import {EnvVars} from "../../models/env-vars.i";
import {Observable} from "rxjs/Observable";

declare var ENV: EnvVars;

/*
  Generated class for the PlanResourceProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class PlanResourceProvider {

    constructor(public authHttp: AuthHttp) {
        console.log('Hello PlanResourceProvider Provider');
    }

    all(): Observable<Array<Object>> {
        return this.authHttp.get(`${ENV.API_URL}/plans`)
            .map(response => response.json().plans);
    }
}
