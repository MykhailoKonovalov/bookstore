import {app} from "./bootstrap.js";
import DiscoverController from "./controllers/discover_controller";

app.register('discover', DiscoverController);