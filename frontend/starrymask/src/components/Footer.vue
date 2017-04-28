<template>
  <footer class="footer">
    <div class="container">
      <ul class="society-list">
        <li><a href="#"><i class="iconfont">&#xe69f;</i></a></li>
      </ul>
      <p class="copyright">StarryMask V1.1.0</p>
      <p class="copyright">&copy;2017 KAPETER.COM 浙ICP备14040866号-1</p>
    </div>
    <canvas id="cover"></canvas>
  </footer>
</template>

<script>
  export default {
    mounted () {
      let canvas = document.getElementById('cover')
      let ctx = canvas.getContext('2d')
      canvas.width = canvas.parentNode.offsetWidth
      canvas.height = canvas.parentNode.offsetHeight

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
    }
  }
</script>

<style>
  .footer{
    width: 100%;
    padding: 30px 0;
    position: relative;
    text-align: center;
    color: #999;
  }
  .society-list{
    display: inline-block;
  }
  .society-list > li {
    margin:0 15px;
    float: left;
    font-size: 32px;
  }
  .society-list > li > a {
    letter-spacing: 1px;
  }
  .copyright{
    font-size: 12px;
    text-transform: uppercase;
  }
  #cover{
    position: absolute;
    left: 0;
    bottom: 0;
  }
</style>
