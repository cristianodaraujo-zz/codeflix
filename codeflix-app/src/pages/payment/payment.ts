import {Component} from '@angular/core';
import {AlertController, IonicPage, LoadingController, NavController, NavParams} from 'ionic-angular';
import scriptjs from 'scriptjs';
import {Auth} from "../../decorators/auth.decorators";
import {Subject} from "rxjs/Subject";
import {UserResourceProvider} from "../../providers/user-resource/user-resource";
import {PaymentResourceProvider} from "../../providers/payment-resource/payment-resource";
import {SignaturePage} from "../signature/signature";

declare var PAYPAL: any;

/**
 * Generated class for the PaymentPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@Auth()
@IonicPage()
@Component({
    selector: 'page-payment',
    templateUrl: 'payment.html',
})
export class PaymentPage {
    user: any = null;
    payment: any = null;
    planId: number = null;
    ppplusLoaded: boolean = false;
    ppp: any = null;
    subject: any = new Subject;
    loading: any = null;

    constructor(public navCtrl: NavController,
                public navParams: NavParams,
                public loadingCtrl: LoadingController,
                public alertCtrl: AlertController,
                public userResource: UserResourceProvider,
                public paymentResource: PaymentResourceProvider) {
        this.planId = +this.navParams.get('plan');
    }

    ionViewDidLoad() {
        this.loading = this.loadingCtrl.create({
            content: 'Carregando'
        });
        this.loading.present();

        this.subject.subscribe( () => {
            this.makePayPalPlus();
        }, () => {
            this.loading.dismiss();
        });

        scriptjs('https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js', () => {
            if (typeof PAYPAL !== undefined) {
                this.ppplusLoaded = true;
                this.subject.next();
            } else {
                this.subject.error('PayPal Plus not loaded');
            }
        });

        this.userResource.get().subscribe((user) => {
            this.user = user;
            this.subject.next();
        }, () => {
            this.subject.error('User not loaded');
        });

        this.paymentResource.get(this.planId).subscribe((payment) => {
            this.payment = payment;
            this.subject.next();
        }, () => {
            this.subject.error('Payment not loaded')
        });
    }

    makePayPalPlus() {
        if (this.ppplusLoaded && this.payment !== null && this.user !== null) {
            this.loading.dismiss();

            let self = this;
            this.ppp = PAYPAL.apps.PPP({
                buttonLocation: 'outside',
                approvalUrl: this.payment.approval_url,
                placeholder: 'ppplus',
                mode: 'sandbox',
                country: 'BR',
                language: 'pt_BR',
                payerFirstName: this.user.name.split(" ")[0],
                payerLastName: this.user.name.split(" ")[0],
                payerEmail: this.user.email,
                payerTaxId: this.user.cpf,
                payerTaxIdType: 'BR_CPF',
                onContinue(cardToken, payerId) {
                    self.doPayment(payerId);
                }
            });
        }
    }

    buy() {
        this.ppp.doContinue();
    }

    doPayment(payerId) {
        this.loading = this.loadingCtrl.create({
            content: 'Realizando pagamento'
        });
        this.loading.present();

        this.paymentResource.does(this.planId, this.payment.payment_id, payerId).subscribe(() => {
            this.loading.dismiss();
            this.navCtrl.setRoot('Signature');
        }, () => {
            this.loading.dismiss();
            let alert = this.alertCtrl.create({
                title: 'Mensagem de erro',
                subTitle: 'Ops! Seu pagamento não foi aprovado.',
                buttons: ['OK']
            });
            alert.present();
        });
    }
}
