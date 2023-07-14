import './assets/style.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import { ApolloClient, InMemoryCache } from '@apollo/client/core'
import VueApolloComponents from '@vue/apollo-components'
import {createApolloProvider} from '@vue/apollo-option'

// ...

const cache = new InMemoryCache()

const apolloClient = new ApolloClient({
  cache,
  uri: 'http://localhost:8000/graphql',
})

const apolloProvider = createApolloProvider({
    defaultClient: apolloClient,
})

const app = createApp(App);
app.use(router)
app.use(apolloProvider)
app.use(VueApolloComponents)
app.mount('#app')
