import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  //{
  //  path: '/',
  //  name: 'Welcome',
  //  component: () => import(/* webpackChunkName: "about" */ '../views/Welcome.vue'),
  //  meta: {
  //    title: 'CodeTry - Welcome',
  //    metaTags: [
  //      {
  //        name: 'description',
  //        content: 'The welcome page on CodeTry portal.'
  //      },
  //      {
  //        property: 'og:description',
  //        content: 'The welcome page on CodeTry portal.'
  //      }
  //    ]
  //  }
  //},
  //{
  //  path: '/mock-server',
  //  name: 'MockServer',
  //  component: () => import(/* webpackChunkName: "about" */ '../views/MockServer.vue'),
  //  meta: {
  //    title: 'CodeTry - MockServer',
  //    metaTags: [
  //      {
  //        name: 'description',
  //        content: 'This page need for create MockServer for your integration tests.'
  //      },
  //      {
  //        property: 'og:description',
  //        content: 'This page need for create MockServer for your integration tests.'
  //      }
  //    ]
  //  }
  //},
  {
    path: '/',
    component: () => import(/* webpackChunkName: "about" */ '../views/PhpSandbox.vue'),
    meta: {
      title: 'CodeTry - PHP Sandbox',
      metaTags: [
        {
          name: 'description',
          content: 'Try your php code in this PHP Sandbox.'
        },
        {
          property: 'og:description',
          content: 'Try your php code in this PHP Sandbox.'
        }
      ]
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

// This callback runs before every route change, including on page load.
router.beforeEach((to, from, next) => {
  // This goes through the matched routes from last to first, finding the closest route with a title.
  // e.g., if we have `/some/deep/nested/route` and `/some`, `/deep`, and `/nested` have titles,
  // `/nested`'s will be chosen.
  const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

  // Find the nearest route element with meta tags.
  const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

  // If a route with a title was found, set the document (page) title to that value.
  if(nearestWithTitle) document.title = nearestWithTitle.meta.title;

  // Remove any stale meta tags from the document using the key attribute we set below.
  Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => {
    if (el.parentNode) {
      el.parentNode.removeChild(el)
    }
  });

  // Skip rendering meta tags if there are none.
  if(!nearestWithMeta) return next();

  // Turn the meta tag definitions into actual elements in the head.
  nearestWithMeta.meta.metaTags.map((tagDef: never) => {
    const tag = document.createElement('meta');

    Object.keys(tagDef).forEach(key => {
      tag.setAttribute(key, tagDef[key]);
    });

    // We use this to track which meta tags we create so we don't interfere with other ones.
    tag.setAttribute('data-vue-router-controlled', '');

    return tag;
  })
  // Add the meta tags to the document head.
  .forEach((tag: never) => document.head.appendChild(tag));

  next();
});

export default router
