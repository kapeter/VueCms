<template>
  <div id="canvas" class="canvas"></div>
</template>

<script>
import Konva from 'konva/src/Core'
import Tween from 'konva/src/Tween'
import Animation from 'konva/src/Animation'
import Arc from 'konva/src/shapes/Arc'
import Line from 'konva/src/shapes/Line'

export default {
  data () {
    return {
      timer: null
    }
  },
  mounted () {
    const MAX_RADIUS = 60
    const MIN_RADIUS = 30
    const MAX_LENGTH = 250
    const MIN_LENGTH = 175
    const MAX_WIDTH = 3
    const MIN_WIDTH = 1
    const MAX_COUNT = 6
    const MIN_COUNT = 2
    const COLORS = ['#FF435A', '#FFED00', '#39c5bb', '#8778D5', '#449AFF', '#66ccff']

    let winWidth = window.innerWidth
    let winHeight = window.innerHeight
    let _self = this

    let stage = new Konva.Stage({
      container: 'canvas',
      width: winWidth,
      height: winHeight
    })

    let layerArc = new Konva.Layer()
    stage.add(layerArc)

    let layerLine = new Konva.Layer()
    stage.add(layerLine)

    animate()

    _self.timer = setInterval(() => {
      animate()
    }, 1750)

    function animate () {
      setArcs()
      setTimeout(() => {
        setlines()
      }, 500)
    }

    function setArcs () {
      let arcs = []
      let len = _self.getRandom(MIN_COUNT, MAX_COUNT)

      layerArc.destroyChildren()

      for (let i = 0; i < len; i++) {
        let arcR = _self.getRandom(MIN_RADIUS, MAX_RADIUS)
        let arcX = _self.getRandom(arcR * 2, winWidth - arcR * 2)
        let arcY = _self.getRandom(arcR * 2, winHeight - arcR * 2)
        let arcC = _self.getRandom(0, COLORS.length)
        let arcW = _self.getRandom(MIN_WIDTH, MAX_WIDTH)
        let arcD = _self.getRandom(0, 180)
        arcs[i] = new Konva.Arc({
          x: arcX,
          y: arcY,
          innerRadius: arcR,
          outerRadius: arcR,
          stroke: COLORS[arcC],
          strokeWidth: arcW,
          rotation: arcD,
          angle: 0
        })
        layerArc.add(arcs[i])
        
        arcs[i].to({
          angle: 360,
          duration: 1,
          strokeWidth: arcW + 1,
          easing: Konva.Easings.StrongEaseIn,
          onFinish: () => {
            arcs[i].to({
              strokeWidth: MIN_WIDTH,
              opacity: 0,
              duration: 0.75,
              easing: Konva.Easings.EaseInOut
            })
          }
        })
      }

      layerArc.draw()
    }

    function setlines () {
      let lines = []
      let len = _self.getRandom(MIN_COUNT, parseInt(MAX_COUNT / 2))

      layerLine.destroyChildren()

      for (let i = 0; i < len; i++) {
        let lineL = _self.getRandom(MIN_LENGTH, MAX_LENGTH)
        let delta = Math.sqrt(lineL * lineL / 2)
        let lineX1 = _self.getRandom(delta, winWidth)
        let lineY1 = _self.getRandom(delta, winHeight)
        let lineX2 = lineX1 - delta
        let lineY2 = lineY1 - delta
        let lineC = _self.getRandom(0, COLORS.length)
        let lineW = _self.getRandom(MIN_WIDTH, MAX_WIDTH)

        lines[i] = new Konva.Line({
          points: [lineX1, lineY1, lineX1, lineY1],
          stroke: COLORS[lineC],
          strokeWidth: MIN_WIDTH
        })
        layerLine.add(lines[i])

        lines[i].to({
          points: [lineX1, lineY1, lineX2, lineY2],
          duration: 0.5,
          easing: Konva.Easings.EaseInOut,
          strokeWidth: lineW,
          onFinish: () => {
            lines[i].to({
              points: [lineX2, lineY2, lineX2, lineY2],
              duration: 0.5,
              strokeWidth: MIN_WIDTH
            })
          }
        })
      }

      layerLine.draw()
    }
  },
  beforeDestroy () {
    clearInterval(this.timer)
  },
  methods: {
    getRandom (lowerValue, upperValue) {
      return parseInt(Math.random() * (upperValue - lowerValue + 1) + lowerValue)
    },
  }
}
</script>

<style>
  .canvas{
    position: fixed;
    left: 0;
    top: 0;
    z-index: -1;
  }
</style>
