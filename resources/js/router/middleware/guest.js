export default function guest({next,store}) {
    console.log("🚀 ~ file: auth.js ~ line 3 ~ auth ~ store.getters['auth/getAuth']", store.getters['auth/getAuth'])
   
    if(store.getters['auth/getAuth'].loggedIn) {
        console.log('I am here')
        return next({
            name: 'Home'
        })
    }

    return next();
}