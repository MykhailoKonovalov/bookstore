import {Controller} from "@hotwired/stimulus";

export default class DiscoverController extends Controller {
    redirectTo(event) {
        const dataHref: Location = event.target.value;

        if (dataHref) {
            window.location = dataHref;
        }
    }
}