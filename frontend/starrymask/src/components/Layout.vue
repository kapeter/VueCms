<template>
  <div>
    <HeaderPart></HeaderPart>
    <main class="main">
      <div class="container" id="content">
        <router-view></router-view>
      </div>
    </main>
    <canvas id="cover"></canvas>
  </div>
</template>

<script>
  import HeaderPart from './Header.vue'

  export default {
    components: {
      HeaderPart
    },
    mounted () {
      let canvas = document.getElementById('cover')
      let ctx = canvas.getContext('2d')
      canvas.width = window.innerWidth
      canvas.height = window.innerHeight

      let step = 0
      let lines = ['rgba(57, 197, 187, 0.2)', 'rgba(57, 197, 187, 0.25)', 'rgba(57, 197, 187, 0.3)']
      function loop () {
        ctx.clearRect(0, 0, canvas.width, canvas.height)
        step++
        for (let j = lines.length - 1; j >= 0; j--) {
          ctx.fillStyle = lines[j]
          let angle = (step + j * 90) * Math.PI / 180
          let deltaHeight = Math.sin(angle) * 50
          let deltaHeightRight = Math.cos(angle) * 50
          let waveH = canvas.height
          ctx.beginPath()
          ctx.moveTo(0, waveH + deltaHeight)
          ctx.bezierCurveTo(canvas.width / 2, waveH + deltaHeight - 50, canvas.width / 2, waveH + deltaHeightRight - 50, canvas.width, waveH + deltaHeightRight)
          ctx.lineTo(canvas.width, canvas.height)
          ctx.lineTo(0, canvas.height)
          ctx.lineTo(0, waveH + deltaHeight)
          ctx.closePath()
          ctx.fill()
        }
        requestAnimationFrame(loop)
      }
      loop()

      let mainDom = document.getElementById('content')
      mainDom.style.height = (window.innerHeight - 50) + 'px'
    }
  }
</script>

<style>
  .header{
    padding: 60px 0;
  }
  .logo, .slogan{
    width: 100%;
    text-align: center;
  }
  .slogan{
    color: #666;
    font-size: 16px;
    font-style: italic;
    letter-spacing: 1px;
    margin-top: 15px;
  }
  .nav{
    width: 100%;
    height: 60px;
    margin-top: 30px;
    text-align: center;
    border-top: 1px #ddd solid;
    border-bottom: 1px #ddd solid;
  }
  .nav > ul {
    display: inline-block;
    line-height: 60px;
  }
  .nav > ul:after{
    content: '';
    display: block;
    clear: both;
    height: 0;
  }
  .nav > ul > li {
    margin: 0 15px;
    float: left;
    text-align: center;
  }
  .main{
    position: relative;
    width: 100%;
  }
  .container{
    position: relative;
    width: inherit;
    max-width: 1200px;
    margin:0 auto;
    z-index: 10;
  }
  canvas{
    position: absolute;
    left: 0;
    bottom: 0;
  }
</style>
