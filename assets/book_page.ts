import {app} from './bootstrap.js';
import BookPageController from "./controllers/book_page_controller";

app.register('bookPage', BookPageController)