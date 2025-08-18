import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'flowbite';
import 'flowbite/dist/flowbite.min.css';
import "@hotwired/hotwire-native-bridge"
import {registerPeriodicSync} from '@spomky-labs/pwa/helpers';

await registerPeriodicSync('ping', 5000);
