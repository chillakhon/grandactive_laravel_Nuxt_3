// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: false },
  modules: [
    '@pinia/nuxt',
    '@nuxtjs/tailwindcss',
  ],
  plugins: [
    { src: '~/plugins/bootstrap.js', mode: 'client' }
  ],

  components: {
     global: true,
     dirs: ['~/components']
  },
})
