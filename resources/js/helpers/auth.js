const axios = require('axios')

export function getLocalUser() {
  let userStr = localStorage.getItem("user")

  if(userStr) {
    return JSON.parse(userStr)

  }else if(!userStr){
    userStr = window.User
  }else if (!window.User) {
    userStr = null
  }

  return userStr

}

export function getLocalUserFactoryId(user) {

  // axios.get(`/api/v1/userfactories/${user.id}`, {
  //   })
  //   .then((response) => {
  //     context.commit('updateFactory', response.data.factoryId)
  //   })
}