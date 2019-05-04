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
    profiles: [],
    profile: [],
    matchedUsers: [],
    messages: [],
  },

  getters: {
    currentUser (state) {
      return state.currentUser
    },

    profiles (state) {
      return state.profiles
    },

    profile (state) {
      return state.profile
    },

    matchedUsers (state) {
      return state.matchedUsers
    },

    matchedFirstUser (state) {
      return state.matchedUsers[0]
    },

    messages (state) {
      return state.messages
    },

    lastMessage (state) {
      return state.messages.slice(-1)[0]
    },

  },

  mutations: {
    updateProfiles (state, payload) {
      state.profiles = payload
    },

    updateProfile (state, payload) {
      state.profile = payload
    },

    updateMatchedUsers (state, payload) {
      state.matchedUsers = payload
    },

    updateMessages (state, payload) {
      state.messages = payload
    },

    logout (state) {
      localStorage.removeItem('user')
      state.isLoggedIn = false
      state.currentUser = null
    }
  },

  actions: {
    getProfile ({ commit }, {profileId}) {
      axios
        .get(`/api/v1/profiles/${profileId}`)
        .then((response) => {
          commit('updateProfile', response.data.profile || [])
        })
        .catch((err) => {
          alert(err)
        })
    },

    getProfiles ({ commit }) {
      axios
        .get(`/api/v1/profiles/`)
        .then((response) => {
          commit('updateProfiles', response.data.profiles || [])
        })
        .catch((err) => {
          alert(err)
        })
    },

    searchProfiles ({ commit }, {data}) {
      axios
        .post(`/api/v1/profiles/search`,{
          data: data
        })
        .then((response) => {
          commit('updateProfiles', response.data.profiles || [])
        })
        .catch((err) => {
          alert(err)
        })
    },
    updateProfile ({ commit }, {data}) {
      axios
        .put(`/api/v1/profiles/${data[0].id}`,{
          id: data[0].id,
          name: data[0].name,
          introduce: data[0].introduce,
          address: data[0].address,
          job: data[0].job,
          salary: data[0].salary,
          nomad_flag: data[0].nomad_flag,
          smoke_flag: data[0].smoke_flag,
          alcohol_flag: data[0].alcohol_flag,
        })
        .then((response) => {
          commit('updateProfile', response.data.profile || [])
        })
        .catch((err) => {
          alert(err)
        })
    },
    updateProfileImage ({ commit }, {profileId, image}) {
      let formData = new FormData()
      formData.append('image', image)
      formData.append('profileId', profileId)
      let config = {
          headers: {
              'content-type': 'multipart/form-data'
          }
      }
      config.headers['X-HTTP-Method-Override'] = 'PUT';
      /*
      ** PUTだとfileを送れない
      ** https://qiita.com/komatzz/items/21b58c92e14d2868ac8e
      */
      axios
        .post(`/api/v1/profiles/${profileId}/`, formData, config)
        .then((response) => {
          commit('updateProfile', response.data.profile || [])
        })
        .catch((err) => {
          alert(err)
        })
    },
    matchedUsers ({ commit }, {currentUser}) {
      axios
        .post(`/api/v1/matches/users`,{
          currentUser: currentUser
        })
        .then((response) => {
          commit('updateMatchedUsers', response.data.matchedUsers || [])
        })
        .catch((err) => {
          alert(err)
        })
    },
    getChatMessages ({ commit }, {currentUser, matchId}) {
      axios
        .post(`/api/v1/chats/getChatMessages`,{
          currentUser: currentUser,
          matchId: matchId
        })
        .then((response) => {
          commit('updateMessages', response.data.chatMessages || [])
        })
        .catch((err) => {
          alert(err)
        })
    },
    sendChatMessage ({ commit }, {currentUser, matchId, message}) {
      axios
        .post(`/api/v1/chats/sendChatMessage`,{
          currentUser: currentUser,
          matchId: matchId,
          message: message
        })
        .then((response) => {
          commit('updateMessages', response.data.chatMessages || [])
        })
        .catch((err) => {
          alert(err)
        })
    },
    login ({ commit }) {
      axios
        .get('/auth/login/facebook', {})
        .then((response) => {

        })
    },

    logout ({ commit }) {
      axios
        .post('/logout', {})
        .then((response) => {
          window.location.href = '/'
          // window.location.href = $route
        })
    }
  },
}