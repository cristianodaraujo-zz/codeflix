
import {Injector} from "@angular/core";

let injector: Injector;

export const appContainer = (inject ? : Injector): Injector => {
    if (inject) {
        injector = inject;
    }

    return injector;
}