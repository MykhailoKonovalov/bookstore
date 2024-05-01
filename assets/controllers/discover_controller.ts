import {Controller} from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class DiscoverController extends Controller {
    redirectTo(event) {
        const dataHref: Location = event.target.value;

        if (dataHref) {
            window.location = dataHref;
        }
    }
}