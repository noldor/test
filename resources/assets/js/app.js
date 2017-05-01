
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import EntitySaveEvents from "./events/EntitySaveEvents";
import EntityDeleteEvent from "./events/EntityDeleteEvent";
import AddFilterEvent from "./events/AddFilterEvent";

/**
 * Invoke entity delete events.
 */
EntityDeleteEvent();

/**
 * Invoke form submit events.
 */
EntitySaveEvents();

/**
 * Invoke add filter events.
 */
AddFilterEvent();
