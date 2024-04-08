// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: {enabled: false},
  runtimeConfig :{
    public: {
      APP_URL: 'http://127.0.0.1:8000'
    }
  },
  modules: [
    '@pinia/nuxt',
    '@nuxtjs/tailwindcss',
    '@vesp/nuxt-fontawesome',
    '@nuxt/image-edge'
  ],
  fontawesome: {
    icons: {
      solid: ['coffee', 'child'],
      regular: ['comment'],
      brands: ['twitter']
    }
  },

  plugins: [
    {src: '~/plugins/bootstrap.js', mode: 'client'}
  ],

  components: {
    global: true,
    dirs: ['~/components']
  },
})
