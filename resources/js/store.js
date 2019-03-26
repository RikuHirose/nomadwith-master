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
    entries: [],
    parameters: [],
    machine: [],
  },

  getters: {
    currentUser (state) {
      return state.currentUser
    },

    entries (state) {
       return state.entries
    },

    factory (state) {
      // 現在は1userに対して最大1factoryなので、0番目を選択中の工場情報として返す
      if (state.entries.length === 0) { return null }
      return state.entries[0].factory
    },

    updatedTime (state) {
      // 全データ同じタイミングで更新されるため、更新日時は一つ目のエントリーから判断でok
      if (state.entries.length === 0) { return null }
      return state.entries[0].date
    },

    parameters (state) {
      return state.parameters
    },

    machine (state) {
      return state.machine
    }
  },

  mutations: {
    updateEntries (state, payload) {
      state.entries = payload
    },

    updateParameters (state, payload) {
      state.parameters = payload
    },

    updateMachine (state, payload) {
      state.machine = payload
    },

    setLoading(state, payload) {
      state.loading = payload
    },

    logout (state) {
      localStorage.removeItem('user')
      state.isLoggedIn = false
      state.currentUser = null
    }
  },

  actions: {
    getFactory ({ commit }) {
      commit('setLoading', true)
      axios
        .get(`/api/v1/factory/user/${user.id}`, {})
        .then((response) => {
          commit('updateEntries', response.data.factory || [])
          commit('setLoading', false)
        })
        .catch((err) => {
          alert(err)
          commit('setLoading', false)
        })
    },

    getParameters ({ commit }, {machineId, userId}) {
      commit('setLoading', true)
      axios
        .get(`/api/v1/machine/${machineId}/user/${userId}`)
        .then((response) => {
          commit('updateParameters', response.data.parameters || [])
          commit('updateMachine', response.data.machine || [])
          commit('setLoading', false)
        })
        .catch((err) => {
          alert(err)
          commit('setLoading', false)
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