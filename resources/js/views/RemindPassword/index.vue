<template>
  <div id="body">
    <section>
      <img id="stars" src="../../assets/images/stars.png" alt="">
      <img id="moon" src="../../assets/images/moon.png" alt="">
      <img id="mountains_behind" src="../../assets/images/mountains_behind.png" alt="">

      <div id="remindPassword">
        <RemindPassword />
      </div>

      <img id="mountains_front" src="../../assets/images/mountains_front.png" alt="">
    </section>
  </div>
</template>

<script>

import RemindPassword from '../RemindPassword/RemindPassword';

export default {

    name: 'RemindPasswordIndex',

    components: {
        RemindPassword,
    },

    data() {
        return {
            // Remind Password Information
            Account: {
                email: '',
            },
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
                duration: 50,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#moon',
                top: '-100px',
                duration: 50,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#mountains_behind',
                bottom: '0px',
                duration: 50,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#mountains_front',
                bottom: '-500px',
                duration: 200,
                easing: 'easeInOutSine',
            })

            .add({
                targets: '#remindPassword',
                top: '10%',
                left: '32%',
                duration: 500,
                easing: 'easeInOutSine',
            });
    },

    methods: {},
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

  section img#mountains_front {
    bottom: -100%;
    top: initial;
  }

  section img#mountains_front {
    bottom: -100%;
    top: initial;
  }

  #remindPassword {
    position: absolute;
    top: -2000px;
    justify-content: center;
    align-items: center;
  }

</style>

