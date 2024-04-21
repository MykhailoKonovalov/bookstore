import { startStimulusApp } from '@symfony/stimulus-bridge';
import PasswordVisibility from '@stimulus-components/password-visibility'
import 'swiper/css/bundle'
import CarouselController from "./controllers/carousel_controller";

export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

app.register('password-visibility', PasswordVisibility);
app.register('carousel', CarouselController);