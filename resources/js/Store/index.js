import { createStore } from "vuex";

export default createStore({
  state: {
     cart:localStorage.cart?JSON.parse(localStorage.cart):[]
  },
  getters: {
     
  },
  mutations: {
    updateCart(state){
        state.cart=JSON.parse(localStorage.cart);
    },
    clearCart(state){
        state.cart=[]
    }
  },
  actions: {
      
  },
  modules: {

  }
});