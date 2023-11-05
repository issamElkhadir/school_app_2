import general from './general.json';
import users from './users.json';
import countries from './countries.json';
import currencies from './currencies.json';
import measureUnitCategories from './measure-unit-categories.json';
import measureUnits from './measure-units.json';
import mailServers from './mail-servers.json';
import cities from './cities.json';
import states from './states.json';
import views from './views.json';
import sequences from './sequences.json';
import auth from './auth.json';
import settings from './settings.json';
import translations from './translations.json';

export default {
  ...general,
  ...auth,
  ...users,
  ...currencies,
  ...countries,
  ...measureUnitCategories,
  ...measureUnits,
  ...cities,
  ...states,
  ...mailServers,
  ...views,
  ...sequences,
  ...settings,
  ...translations,
};
