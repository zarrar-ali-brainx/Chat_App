<template>

  <div class="container">
    <div class="row custom-row1 ">
      <div class="app-view-container">
        <div class="login-view">

  <form @submit.prevent="loginData">

    <h2>Login</h2>

    <label>Phone no</label>
    <input type="tel" v-model="user.phone_no" class="form-control"  placeholder="Phone no"/>


    <label>Password</label>
    <input type="password" v-model="user.password" class="form-control"  placeholder="Password"/>

    <button type="submit" class="btn btn-primary">Login</button>
    <span>Didn't have an account? <a href="Register">Register</a> </span>
  </form>
        </div>

      </div>
    </div>
    <div class="row custom-row2 border"></div>
  </div>

</template>


<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
// import Home from "@/components/Home.vue";
import Register from "@/components/Register.vue";
const user = ref({
  phone_no: '',
  password: ''
});
const router = useRouter();
const loginData = () => {
  axios.post('http://127.0.0.1:8000/api/login', user.value)
      .then(({ data }) => {
        console.log(data);

            window.localStorage.setItem("api_token", data.access_token);
            // router.push({name: '/'})
        }).catch((err)=> {
          console.log('error');
      });
};

</script>
<style scoped>


.container{
  width: 100%;
  height: 100%;
  overflow: hidden;

}
.custom-row1{

  height: 127px;
  background-color: #00a884;
}
.custom-row2{
  background-color: #dadada;
  height: 830px;
  overflow: hidden;
}
.app-view-container{
  display: flex;
  position: relative;
  justify-content: center;
  align-items: center;



}
.login-view{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 10%;

}



h2{
  font-size: x-large;
  font-weight: bold;
}
form{
  display: flex;
  flex-direction: column;
  width: 420px;
  justify-content: center;

  background-color: #ececec;
  border-radius: 10px;
  border: 2px solid rgba(255, 255, 255, 0.1);
  padding: 50px 35px;
}
form * {

  letter-spacing: 0.5px;
}
label{
  display: block;
  margin-top: 20px;
  font-size: 16px;
  font-weight: 500;

}
input{
  display: block;
  height: 50px;
  width: 100%;
  border-radius: 3px;
  padding: 0 10px;
  margin-top: 8px;
  font-size: 16px;
  font-weight: 300;
  border: none;
  outline: none;
}
button{
  margin-top: 50px;
  width: 100%;
  background-color: #00a884;
  color: #ffffff;
  padding: 15px 0;
  font-size: 18px;
  font-weight: 600;
  border-radius: 5px;
  cursor: pointer;
}
form span{
  display: block;
  margin-top: 35px;
}
a{
  color: rgba(0, 46, 173, 0.8);
}
</style>
