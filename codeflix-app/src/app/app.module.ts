import {BrowserModule} from '@angular/platform-browser';
import {ErrorHandler, NgModule} from '@angular/core';
import {IonicApp, IonicErrorHandler, IonicModule} from 'ionic-angular';

import {MyApp} from './app.component';
import {HomePage} from '../pages/home/home';
import {ListPage} from '../pages/list/list';

import {StatusBar} from '@ionic-native/status-bar';
import {SplashScreen} from '@ionic-native/splash-screen';
import {LoginPage} from "../pages/login/login";
import {Http, HttpModule, XHRBackend} from "@angular/http";
import {JwtClientProvider} from '../providers/jwt-client/jwt-client';
import {IonicStorageModule, Storage} from "@ionic/storage";
import {AuthConfig, AuthHttp, JwtHelper} from "angular2-jwt";
import {AuthProvider} from '../providers/auth/auth';
import {EnvVars} from "../models/env-vars.i";
import {XhrBackendProvider} from '../providers/xhr-backend/xhr-backend';
import {RedirectorProvider} from '../providers/redirector/redirector';
import {Facebook} from "@ionic-native/facebook";
import {UserResourceProvider} from '../providers/user-resource/user-resource';
import {ChangePasswordPage} from "../pages/change-password/change-password";
import {SubscriberPage} from "../pages/subscriber/subscriber";
import {AddCpfPage} from "../pages/add-cpf/add-cpf";
import {PlansPage} from "../pages/plans/plans";
import {TextMaskModule} from "angular2-text-mask";
import {PlanResourceProvider} from '../providers/plan-resource/plan-resource';
import {PaymentPage} from "../pages/payment/payment";
import { PaymentResourceProvider } from '../providers/payment-resource/payment-resource';
import {SignaturePage} from "../pages/signature/signature";

declare var ENV: EnvVars;

@NgModule({
    declarations: [
        MyApp,
        HomePage,
        ListPage,
        LoginPage,
        ChangePasswordPage,
        SubscriberPage,
        AddCpfPage,
        PlansPage,
        PaymentPage,
        SignaturePage,
    ],
    imports: [
        HttpModule,
        BrowserModule,
        TextMaskModule,
        IonicModule.forRoot(MyApp, {}, {
            links: [
                {component: LoginPage, name: 'Login', segment: 'login'},
                {component: HomePage, name: 'Home', segment: 'home'},
                {component: SubscriberPage, name: 'Subscriber', segment: 'subscriber/home'},
                {component: AddCpfPage, name: 'AddCpf', segment: 'add-cpf'},
                {component: ChangePasswordPage, name: 'ChangePassword', segment: 'change-password'},
                {component: PlansPage, name: 'Plans', segment: 'plans'},
                {component: PaymentPage, name: 'Payment', segment: 'plan/:plan/payment'},
                {component: SignaturePage, name: 'Signature', segment: 'subscriber/signature'},
            ]
        }),
        IonicStorageModule.forRoot({
            driverOrder: ['localstorage']
        })
    ],
    bootstrap: [IonicApp],
    entryComponents: [
        MyApp,
        HomePage,
        ListPage,
        LoginPage,
        ChangePasswordPage,
        SubscriberPage,
        AddCpfPage,
        PlansPage,
        PaymentPage,
        SignaturePage,
    ],
    providers: [
        StatusBar,
        SplashScreen,
        {
            provide: ErrorHandler,
            useClass: IonicErrorHandler
        },
        JwtClientProvider,
        JwtHelper,
        AuthProvider,
        {
            provide: AuthHttp,
            deps: [Http, Storage],
            useFactory(http, storage) {
                let authConfig = new AuthConfig({
                    headerPrefix: 'bearer',
                    noJwtError: true,
                    noClientCheck: true,
                    tokenGetter: (() => {
                        return storage.get(ENV.TOKEN_NAME)
                    })
                });

                return new AuthHttp(authConfig, http);
            }
        },
        {
            provide: XHRBackend,
            useClass: XhrBackendProvider
        },
        Facebook,
        RedirectorProvider,
        UserResourceProvider,
        PlanResourceProvider,
        PaymentResourceProvider,
    ]
})
export class AppModule {
}
