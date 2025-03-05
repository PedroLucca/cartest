<template>
  <form @submit.prevent="submit" class="h-screen flex flex-col md:flex-row body-background">
    <div class="flex flex-col md:flex-row w-full h-full">
      <!-- Lado Esquerdo -->
      <div class="hidden bg-white flex-col justify-center items-center border-r text-center ">
        <img src="/images/background.jpg" style="width: 100%">
      </div>
      <!-- Lado Direito -->
      <div class="fixed inset-0 md:static md:w-1/3 bg-white p-4 md:p-8 rounded-lg shadow-md flex flex-col items-center justify-center" style=" height: 163.5vh; position: fixed; top: 0; left: 0;   overflow: hidden;
">
        <!-- logo -->
        <div class=" mb-8 md:mb-20 w-full flex justify-center">
          <svg width="178" height="98" viewBox="0 0 158 78" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M25.6 63.024C20.992 63.024 16.96 62.192 13.504 60.528C10.048 58.8213 7.36 56.4747 5.44 53.488C3.56267 50.4587 2.624 46.96 2.624 42.992C2.624 39.0667 3.30667 35.4613 4.672 32.176C6.08 28.8907 8.04267 26.0533 10.56 23.664C13.0773 21.2747 16.064 19.44 19.52 18.16C22.976 16.8373 26.7733 16.176 30.912 16.176C35.2213 16.176 39.04 16.944 42.368 18.48C45.696 20.016 48.1707 22.2347 49.792 25.136L38.912 33.648C37.9733 31.984 36.7573 30.704 35.264 29.808C33.7707 28.8693 32 28.4 29.952 28.4C28.16 28.4 26.5173 28.7413 25.024 29.424C23.5733 30.064 22.3147 31.0027 21.248 32.24C20.1813 33.4347 19.3493 34.864 18.752 36.528C18.1547 38.192 17.856 40.0267 17.856 42.032C17.856 43.7813 18.24 45.3173 19.008 46.64C19.776 47.9627 20.8427 48.9867 22.208 49.712C23.616 50.4373 25.2373 50.8 27.072 50.8C28.8213 50.8 30.528 50.3947 32.192 49.584C33.8987 48.7733 35.52 47.4507 37.056 45.616L45.952 54.128C43.2213 57.456 40.1707 59.7813 36.8 61.104C33.472 62.384 29.7387 63.024 25.6 63.024Z" fill="#E36600"/>
<path d="M47.82 49.36C46.524 49.36 45.252 49.012 44.004 48.316C42.756 47.596 41.724 46.564 40.908 45.22C40.116 43.852 39.72 42.196 39.72 40.252C39.72 38.62 39.996 37.12 40.548 35.752C41.1 34.384 41.856 33.196 42.816 32.188C43.8 31.156 44.916 30.364 46.164 29.812C47.436 29.236 48.78 28.948 50.196 28.948C51.732 28.948 53.064 29.26 54.192 29.884C55.32 30.508 56.124 31.564 56.604 33.052C57.108 34.516 57.156 36.544 56.748 39.136C56.412 41.248 55.836 43.072 55.02 44.608C54.228 46.144 53.232 47.32 52.032 48.136C50.832 48.952 49.428 49.36 47.82 49.36ZM50.88 42.952C51.6 42.952 52.224 42.772 52.752 42.412C53.28 42.028 53.688 41.5 53.976 40.828C54.288 40.156 54.444 39.364 54.444 38.452C54.444 37.54 54.18 36.796 53.652 36.22C53.148 35.644 52.44 35.356 51.528 35.356C50.832 35.356 50.208 35.548 49.656 35.932C49.128 36.292 48.708 36.808 48.396 37.48C48.108 38.152 47.964 38.944 47.964 39.856C47.964 40.768 48.216 41.512 48.72 42.088C49.248 42.664 49.968 42.952 50.88 42.952ZM52.788 49L53.328 46.336L54.66 39.136L55.704 32.008L56.244 29.308H64.38L60.456 49H52.788ZM64.027 49L67.951 29.308H75.619L74.503 34.888L73.747 33.304C74.563 31.744 75.691 30.628 77.131 29.956C78.595 29.284 80.263 28.948 82.135 28.948L80.695 36.148C80.359 36.1 80.047 36.064 79.759 36.04C79.495 36.016 79.219 36.004 78.931 36.004C77.587 36.004 76.495 36.304 75.655 36.904C74.839 37.504 74.287 38.5 73.999 39.892L72.163 49H64.027ZM90.4043 49.36C88.7243 49.36 87.2963 49.048 86.1203 48.424C84.9443 47.8 84.1163 46.888 83.6363 45.688C83.1563 44.464 83.0843 43 83.4203 41.296L86.6963 24.88H94.8323L91.5563 41.26C91.4363 41.932 91.5083 42.424 91.7723 42.736C92.0363 43.048 92.4443 43.204 92.9963 43.204C93.3323 43.204 93.6323 43.168 93.8963 43.096C94.1843 43 94.4843 42.88 94.7963 42.736L95.7323 48.208C94.9883 48.616 94.1483 48.904 93.2123 49.072C92.3003 49.264 91.3643 49.36 90.4043 49.36ZM81.6923 36.328L82.8803 30.388H97.7483L96.5603 36.328H81.6923ZM108.74 49.36C106.58 49.36 104.684 48.988 103.052 48.244C101.444 47.5 100.184 46.444 99.2716 45.076C98.3596 43.708 97.9036 42.1 97.9036 40.252C97.9036 38.092 98.4076 36.16 99.4156 34.456C100.424 32.752 101.84 31.408 103.664 30.424C105.512 29.44 107.66 28.948 110.108 28.948C112.22 28.948 114.02 29.32 115.508 30.064C116.996 30.808 118.136 31.828 118.928 33.124C119.72 34.42 120.116 35.92 120.116 37.624C120.116 38.224 120.068 38.812 119.972 39.388C119.9 39.964 119.804 40.516 119.684 41.044H104.384L105.14 37.12H115.94L112.556 38.164C112.748 37.396 112.736 36.748 112.52 36.22C112.328 35.668 111.992 35.248 111.512 34.96C111.032 34.648 110.444 34.492 109.748 34.492C108.764 34.492 107.984 34.756 107.408 35.284C106.832 35.812 106.412 36.496 106.148 37.336C105.908 38.176 105.788 39.052 105.788 39.964C105.788 41.188 106.112 42.064 106.76 42.592C107.432 43.096 108.404 43.348 109.676 43.348C110.42 43.348 111.164 43.24 111.908 43.024C112.652 42.784 113.336 42.436 113.96 41.98L117.344 46.912C116 47.824 114.596 48.46 113.132 48.82C111.692 49.18 110.228 49.36 108.74 49.36ZM128.555 49.36C126.803 49.36 125.135 49.192 123.551 48.856C121.991 48.496 120.779 48.064 119.915 47.56L122.723 42.016C123.707 42.616 124.811 43.072 126.035 43.384C127.283 43.672 128.459 43.816 129.563 43.816C130.475 43.816 131.099 43.732 131.435 43.564C131.795 43.372 131.975 43.144 131.975 42.88C131.975 42.592 131.735 42.388 131.255 42.268C130.775 42.124 130.151 42.004 129.383 41.908C128.639 41.812 127.847 41.668 127.007 41.476C126.167 41.284 125.363 41.008 124.595 40.648C123.851 40.264 123.239 39.736 122.759 39.064C122.279 38.392 122.039 37.504 122.039 36.4C122.039 34.696 122.531 33.304 123.515 32.224C124.523 31.12 125.867 30.304 127.547 29.776C129.227 29.224 131.087 28.948 133.127 28.948C134.567 28.948 135.947 29.08 137.267 29.344C138.611 29.584 139.799 29.944 140.831 30.424L138.023 35.968C136.991 35.368 135.959 34.972 134.927 34.78C133.919 34.588 132.995 34.492 132.155 34.492C131.219 34.492 130.571 34.6 130.211 34.816C129.851 35.008 129.671 35.224 129.671 35.464C129.671 35.752 129.911 35.968 130.391 36.112C130.871 36.256 131.483 36.388 132.227 36.508C132.971 36.604 133.763 36.748 134.603 36.94C135.467 37.108 136.271 37.384 137.015 37.768C137.759 38.128 138.371 38.644 138.851 39.316C139.331 39.988 139.571 40.876 139.571 41.98C139.571 43.612 139.067 44.98 138.059 46.084C137.075 47.188 135.743 48.016 134.063 48.568C132.407 49.096 130.571 49.36 128.555 49.36ZM150.135 49.36C148.455 49.36 147.027 49.048 145.851 48.424C144.675 47.8 143.847 46.888 143.367 45.688C142.887 44.464 142.815 43 143.151 41.296L146.427 24.88H154.563L151.287 41.26C151.167 41.932 151.239 42.424 151.503 42.736C151.767 43.048 152.175 43.204 152.727 43.204C153.063 43.204 153.363 43.168 153.627 43.096C153.915 43 154.215 42.88 154.527 42.736L155.463 48.208C154.719 48.616 153.879 48.904 152.943 49.072C152.031 49.264 151.095 49.36 150.135 49.36ZM141.423 36.328L142.611 30.388H157.479L156.291 36.328H141.423Z" fill="#E36600"/>
</svg>

        </div>
        <!--inputs-->
        <div class="space-y-5 mb-12 md:mb-60 w-full">    
          <div class="w-4/5 md:w-2/3 mx-auto">    
            <span class="p-float-label">
              <InputText type="text" v-model="form.email" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required/>
              <label>E-mail *</label>
            </span>
            <br>
            <div class="p-field p-col-12 p-md-6">
              <span class="p-float-label w-full">
                <Password v-model="form.password" :feedback="false" class="w-full" toggleMask autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required/>
                <label for="">Senha</label>
              </span>
            </div>
          </div>
          <!-- esqueceu a senha-->
          <div class="text-center">
            <a :href="route('forgot.password')"
              class="text-primary uppercase font-extrabold text-[12px] block">ESQUECEU SUA SENHA?</a>
          </div>
          
            <span class="text-xs text-center flex justify-center bg-red-500 rounded-md p-3 text-white" v-if="$page.props.errorBags?.default">
          Dados incorretos, favor verificar.
          </span>
          <!-- botão entrar-->
          <div class="w-4/5 md:w-2/3 mx-auto flex flex-col justify-between h-full">
        
            <button type="submit"
              class="bg-primary text-white rounded-md py-4 w-full text-sm flex items-center justify-center hover:bg-MIGamarelo "
              :class="{ 'bg-opacity-70 cursor-wait': sending }">
              <svg v-if="sending" role="status"
                class="w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-200 fill-blue-600" viewBox="0 0 100 101"
                fill="none" xmlns="http://www.w3.org/2000/svg">
              </svg>
              <span>Entrar</span>
            </button>
          </div>
        </div>
        <div class="flex justify-center mt-4">
          <span class="text-gray-400 text-[10px]"> &copy; 2023 - Projeto Estagio ProConph | Todos os direitos reservados. | Política de
            Privacidade ©</span>
        </div>
      </div>
    </div>
  </form>
</template>





<script>
import Layout from "../../Layouts/Auth.vue";
export default {
  layout: [Layout],
};
</script>

<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import { ref, onUnmounted } from "vue";
import InputText from "primevue/inputtext";
import Password from "primevue/password";


const toast = useToast();
const sending = ref(false);
const error = ref(false);

const form = useForm({
  email: "",
  password: "",
});

function submit() {
  sending.value = true;
  if(form.email && form.password){

  form.post(route("action.login"), {
    onSuccess: () => (window.location.href = "/index"),
    onFinish: () => (sending.value = false),
  });
  } else {
    sending.value = false
  }
}

onUnmounted(() => {
  let body = document.querySelector(".body-background");
  body.classList.remove(".body-background");
});
</script>

<style>
.body-background {
  background-image: url("/images/background.jpg");
  background-repeat: no-repeat;
  background-size: 100% 100% 100% 100%;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  height: 163.5vh;
}

</style>


