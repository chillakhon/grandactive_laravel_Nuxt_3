import Vue from 'vue'
import Pusher from 'pusher-js'

export default (context, inject) => {
    Pusher.logToConsole = true

    const pusher = new Pusher('6c17bd8627071788d0e4', {
        cluster: 'ap2'
    })

    provide('pusher', pusher)
    inject('pusher', pusher)
}