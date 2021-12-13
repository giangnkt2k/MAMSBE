<template>
  <div id="body">
    <section>
      <img id="stars" src="../../assets/images/stars.png" alt="">
      <img id="moon" src="../../assets/images/moon.png" alt="">
      <img id="mountains_behind" src="../../assets/images/mountains_behind.png" alt="">

      <div id="registerArea">
        <Register />
      </div>

      <img id="mountains_front" src="../../assets/images/mountains_front.png" alt="">
    </section>
  </div>
</template>

<script>

import Register from '../Register/Register';

export default {

    name: 'RegisterIndex',

    status: false,

    components: {
        Register,
    },

    data() {
        return {
            // Account Register
            Account: {
                name: '',
                phone: '',
                email: '',
                password: '',
                password_confirmation: '',
            },

            input_1: '',
            input_2: '',
        };
    },

    mounted() {
        var animation = this.$anime.timeline({
            autoplay: true,
        });

        animation
            .add({
                targets: '#stars',
                top: '0px',
                duration: 100,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#moon',
                top: '-100px',
                duration: 100,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#mountains_behind',
                bottom: '0px',
                duration: 100,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#mountains_front',
                bottom: '-500px',
                duration: 200,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#registerArea',
                top: '10%',
                left: '32%',
                duration: 500,
                easing: 'easeInOutSine',
            });
    },

    methods: {
    },
};
</script>

<style scoped>

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  #body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(#2b1055, #7597de);
  }

  section {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }

  section h2 {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }

  section a {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }

  section img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    pointer-events: none;
  }

  section img#moon {
    top: -100%;
    mix-blend-mode: screen;
  }

  section img#stars {
    top: -100%;
    height: 100%;
    object-fit: cover;
  }

  section img#mountains_behind {
    bottom: -100%;
    top: initial;
  }

  section img#mountains_front {
    bottom: -110%;
    top: initial;
    z-index: 1000;
  }

  #text {
    position: absolute;
    color: #fff;
    font-size: 2vw;
    font-weight: 200;
  }

  #text span {
    font-weight: 700;
  }

  #btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    margin-top: 100px;
    text-decoration: none;
    display: inline-block;
    padding: 8px 50px;
    background: #fff;
    border-radius: 40px;
    font-size: 1.4em;
    color: #2b1055;
    z-index: 10000;
  }

  #registerArea {
    position: absolute;
    top: -2000px;
    justify-content: center;
    align-items: center;
  }

</style>

