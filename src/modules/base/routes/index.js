import userRoutes from './user-routes';
import currencyRoutes from './currency-routes';
import cityRoutes from './city-routes';
import stateRoutes from './state-routes';
import countryRoutes from './country-routes';
import uomCategoryRoutes from './uom-category-routes';
import uomRoutes from './uom-routes';
import sequenceRoutes from './sequence-routes';
import mailServerRoutes from './mail-server-routes';
import settingsRoutes from './settings-routes';
import translationRoutes from './translation-routes';
import schoolRoutes from './school-routes';
import permissionRoutes from './permission-routes';

export default {
  name: 'base',
  path: '',
  meta: {
    module: 'base'
  },
  component: () => import('@base/layouts/BaseLayout.vue'),
  children: [
    ...userRoutes,
    ...currencyRoutes,
    ...cityRoutes,
    ...stateRoutes,
    ...countryRoutes,
    ...uomCategoryRoutes,
    ...uomRoutes,
    ...sequenceRoutes,
    ...mailServerRoutes,
    ...settingsRoutes,
    ...translationRoutes,
    ...schoolRoutes,
    ...permissionRoutes,
  ]
};
