import type Axios from 'axios'

declare global {
  interface Window {
    axios: typeof Axios
  }
}

export {}
