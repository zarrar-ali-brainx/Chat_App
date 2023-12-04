<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const user = ref({
  name: '',
  phone_no: '',
  password: ''
});
const router1 = useRouter();
const saveData = () => {
  axios.post('http://127.0.0.1:8000/api/register', user.value)
      .then(({ data }) => {
        console.log(data);
        try {
          router1.push({name: 'Login'});
        } catch (err) {
          alert('failed');
        }
      });
};
</script>

<template>
  <div class="container">
      <div class="row custom-row1 ">
       <div class="app-view-container">
         <div class="register-view">

         <form  @submit.prevent="saveData">
           <h2>Register</h2>

             <label>Name</label>
              <input type="text" v-model="user.name" name="name" id="name" class ="form-control"/>


             <label>Phone no</label>
              <input type="tel" v-model="user.phone_no" name="phone_no" id="phone_no" class ="form-control"/>

            <label>Password</label>
             <input type="password" v-model="user.password" name="password" id="password" class ="form-control"/>


             <button type="submit" value="Save" >Register</button>

              <span>Already have an account? <a href="Login"> Log In</a></span>
         </form>
        </div>

  </div>
      </div>
    <div class="row custom-row2 border"></div>
  </div>
</template>

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


//margin-top: 1.5%;

}
.register-view{
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