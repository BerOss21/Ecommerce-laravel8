import { createStore } from "vuex";

export default createStore({
  state: {
     cart:localStorage.cart?JSON.parse(localStorage.cart):[],
     totalCost:localStorage.totalCost?localStorage.totalCost:0,
  },
  getters: {
     
  },
  mutations: {
    updateCart(state){
      state.cart=localStorage.cart?JSON.parse(localStorage.cart):[],
      state.totalCost=localStorage.totalCost?localStorage.totalCost:0;
    },

    clearCart(state){
        state.cart=[]
        state.totalCost=0
    },
  },
  actions: {
      
  },
  modules: {

  }
});