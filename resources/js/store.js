import {getLocalUser} from './helpers/auth'
import {getLocalUserFactoryId} from './helpers/auth'

const user = getLocalUser()
// const factoryId = getLocalUserFactoryId(user)

export default {
  state: {
    currentUser: user,
    isLoggedIn: !!user,
    loading: false,
    auth_error: null,
    profile: [],
  },

  getters: {
    currentUser (state) {
      return state.currentUser
    },

    updatedTime (state) {
      // 全データ同じタイミングで更新されるため、更新日時は一つ目のエントリーから判断でok
      if (state.entries.length === 0) { return null }
      return state.entries[0].date
    },

    profile (state) {
      return state.profile
    },

  },

  mutations: {
    updateProfile (state, payload) {
      state.profile = payload
    },

    logout (state) {
      localStorage.removeItem('user')
      state.isLoggedIn = false
      state.currentUser = null
    }
  },

  actions: {

    getProfiles ({ commit }, {profileId}) {
      axios
        .get(`/api/v1/profiles/${profileId}`)
        .then((response) => {
          commit('updateProfile', response.data.profile || [])
        })
        .catch((err) => {
          alert(err)
        })
    },

    clearParameters ({ commit }) {
      commit('updateMachine', [])
      commit('updateParameters', [])
    },

    logout ({ commit }) {
      axios
        .post('/signout', {})
        .then((response) => {
          window.location.href = '/signin'
        })
    }
  },
}