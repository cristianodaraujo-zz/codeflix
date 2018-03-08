///<reference path="../providers/redirector/redirector.ts"/>
import {Component, ViewChild} from '@angular/core';
import {Nav, Platform} from 'ionic-angular';
import {StatusBar} from '@ionic-native/status-bar';
import {SplashScreen} from '@ionic-native/splash-screen';

import {HomePage} from '../pages/home/home';
import {ListPage} from '../pages/list/list';
import {LoginPage} from "../pages/login/login";
import {AuthProvider} from "../providers/auth/auth";
import {RedirectorProvider} from "../providers/redirector/redirector";

import md5 from 'crypto-md5';
import {SignaturePage} from "../pages/signature/signature";

@Component({
    templateUrl: 'app.html'
})
export class MyApp {
    @ViewChild(Nav) nav: Nav;

    rootPage: any = LoginPage;
    pages: Array<{ title: string, component: any }>;
    user: any = null;
    urlGravatar: string = null;

    constructor(public platform: Platform,
                public statusBar: StatusBar,
                public splashScreen: SplashScreen,
                public auth: AuthProvider,
                public redirector: RedirectorProvider) {
        this.initializeApp();

        // used for an example of ngFor and navigation
        this.pages = [
            {title: 'Home', component: HomePage},
            {title: 'List', component: ListPage},
            {title: 'Assinaturas', component: SignaturePage},
        ];

    }

    initializeApp() {
        this.auth.getUserSubject().subscribe((user) => {
            this.user = user;
            this.gravatar();
        });
        this.platform.ready().then(() => {
            // Okay, so the platform is ready and our plugins are available.
            // Here you can do any higher level native things you might need.
            this.statusBar.styleDefault();
            this.splashScreen.hide();
        });
    }

    openPage(page) {
        // Reset the content nav to have just this page
        // we wouldn't want the back button to show in this scenario
        this.nav.setRoot(page.component);
    }

    openPageChangePassword() {
        this.nav.setRoot('ChangePassword');
    }

    ngAfterViewInit() {
        this.redirector.config(this.nav);
    }

    logout() {
        return this.auth.setLogout().then(() => {
            return this.redirector.next();
        });
    }

    gravatar() {
        if (this.user) {
            this.urlGravatar = `https://www.gravatar.com/avatar/${md5(this.user.email, 'hex')}`;
        }
    }
}
