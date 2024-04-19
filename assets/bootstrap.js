import { startStimulusApp } from '@symfony/stimulus-bridge';
import PasswordVisibility from '@stimulus-components/password-visibility'
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

app.register('password-visibility', PasswordVisibility);