<template>
  <div>
    <main class="main">
      <div class="container" id="content">
        <div class="border-mask"></div>
        <router-view></router-view>
      </div>
    </main>
    <canvas id="cover"></canvas>
    <p class="clock">
      <span>10h 08m 22.31099s +11° 58’ 01.9516’</span>
    </p>
    <p class="copyright">
      <span>copyrights &copy; kapeter.com. use starryMask theme. </span>
    </p>
  </div>
</template>

<script>
  export default {
    mounted () {
      let canvas = document.getElementById('cover')
      let ctx = canvas.getContext('2d')
      let w = canvas.width = window.innerWidth
      let h = canvas.height = window.innerHeight
      let [hue, stars, count, maxStars] = [0, [], 0, 250]

      let canvas2 = document.createElement('canvas')
      let ctx2 = canvas2.getContext('2d')
      canvas2.width = 100
      canvas2.height = 100

      let half = canvas2.width / 2
      let gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half)

      gradient2.addColorStop(0.025, '#000')
      gradient2.addColorStop(0.1, 'hsl(' + hue + ', 0%, 0%)')
      gradient2.addColorStop(0.25, 'hsl(' + hue + ', 0%, 6%)')
      gradient2.addColorStop(1, 'transparent')

      ctx2.fillStyle = gradient2
      ctx2.beginPath()
      ctx2.arc(half, half, half, 0, Math.PI * 2)
      ctx2.fill()

      // End cache

      function random (min, max) {
        if (arguments.length < 2) {
          max = min
          min = 0
        }

        if (min > max) {
          let hold = max
          max = min
          min = hold
        }

        return Math.floor(Math.random() * (max - min + 1)) + min
      }

      function maxOrbit (x, y) {
        let max = Math.max(x, y)
        let diameter = Math.round(Math.sqrt(max * max + max * max))
        return diameter / 2
      }

      let Star = function () {
        this.orbitRadius = random(maxOrbit(w, h))
        this.radius = random(60, this.orbitRadius) / 15
        this.orbitX = w / 2
        this.orbitY = h / 2
        this.timePassed = random(0, maxStars)
        this.speed = random(this.orbitRadius) / 1200000
        this.alpha = random(2, 10) / 10

        count++
        stars[count] = this
      }

      Star.prototype.draw = function () {
        let x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX
        let y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY
        let twinkle = random(10)

        if (twinkle === 1 && this.alpha > 0) {
          this.alpha -= 0.05
        } else if (twinkle === 2 && this.alpha < 1) {
          this.alpha += 0.05
        }

        ctx.globalAlpha = this.alpha
        ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius)
        this.timePassed += this.speed
      }

      for (let i = 0; i < maxStars; i++) {
        newStar()
      }

      function newStar () {
        return new Star()
      }

      function animation () {
        ctx.globalCompositeOperation = 'source-over'
        ctx.globalAlpha = 1
        ctx.fillStyle = 'hsla(0, 0%, 100%, 1)'
        ctx.fillRect(0, 0, w, h)

        ctx.globalCompositeOperation = 'lighter'
        for (let i = 1, l = stars.length; i < l; i++) {
          stars[i].draw()
        }

        window.requestAnimationFrame(animation)
      }

      animation()

      let mainDom = document.getElementById('content')
      mainDom.style.height = (window.innerHeight - 150) + 'px'
    }
  }
</script>

<style>
  .main{
    position: relative;
    max-width: 1600px;
    margin: 0 auto;
    padding: 75px;
    box-sizing: border-box;
    width: inherit;
    color: #000;
    z-index: 10;
  }
  .container{
    position: relative;
  }
  .border-mask{
      border: rgba(0, 0, 0, 0.25) 1px solid;
      height: 100%;
      width: 100%;
      -webkit-transform-origin: left middle;
      transform-origin: left middle;
      position: absolute;
      left: 0;
      top: 0;
  }
  .mask{
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    z-index: 9;
    background-image: repeating-linear-gradient(-30deg, hsla(0,0%,100%,.05), hsla(0,0%,100%,.05) 1px, transparent 0, transparent 120px),
    repeating-linear-gradient(30deg, hsla(0,0%,100%,.05), hsla(0,0%,100%,.05) 1px, transparent 0, transparent 120px);
  }
  canvas{
    position: absolute;
    left: 0;
    top: 0;
  }
  .copyright,.clock{
    position: fixed;
    color: #000;
    height: 0;
    width: 0;
    white-space: nowrap;
    text-transform: uppercase;
    font-weight: 300;
    font-size: 12px;
    letter-spacing: 0.1em;
  }
  .clock{
    -webkit-transform: translateX(-50%) translateY(-50%) rotate(-90deg);
    transform: translateX(-50%) translateY(-50%) rotate(-90deg);
    left: 35px;
    top: 50%;
  }
  .clock span{
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  }
  .copyright{
    -webkit-transform: translateX(-50%) translateY(-50%) rotate(90deg);
    transform: translateX(-50%) translateY(-50%) rotate(90deg);
    right: 35px;
    bottom: 72px;
  }
  .copyright span{
    position: absolute;
    top: 50%;
    right: 0;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
  }
</style>
