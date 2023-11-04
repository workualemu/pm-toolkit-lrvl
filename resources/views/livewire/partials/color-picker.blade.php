
  <div 
    x-data="app()" 
    x-init="[initColor()]">
    <div>
      <div class="flex flex-row relative">
        <input wire.model="color" id="color-picker" class="border border-gray-400 p-2 rounded-lg" x-model="currentColor">
        <div @click="isOpen = !isOpen" class="cursor-pointer rounded-full ml-3 my-auto h-10 w-10 flex" :class="`bg-${currentColor}`" >
          <svg xmlns="http://www.w3.org/2000/svg" :class="`${iconColor}`" class="h-6 w-6 mx-auto my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
          </svg>
        </div>
        <div class="hidden bg-blue-100 bg-blue-200 bg-blue-300 bg-blue-400 bg-blue-500 bg-blue-600 bg-blue-700 bg-blue-800 bg-blue-900 
        bg-green-100 bg-green-200 bg-green-300 bg-green-400 bg-green-500 bg-green-600 bg-green-700 bg-green-800 bg-green-900 
        bg-red-100 bg-red-200 bg-red-300 bg-red-400 bg-red-500 bg-red-600 bg-red-700 bg-red-800 bg-red-900
        bg-indigo-100 bg-indigo-200 bg-indigo-300 bg-indigo-400 bg-indigo-500 bg-indigo-600 bg-indigo-700 bg-indigo-800 bg-indigo-900 
        bg-teal-100 bg-teal-200 bg-teal-300 bg-teal-400 bg-teal-500 bg-teal-600 bg-teal-700 bg-teal-800 bg-teal-900
        bg-purple-100 bg-purple-200 bg-purple-300 bg-purple-400 bg-purple-500 bg-purple-600 bg-purple-700 bg-purple-800 bg-purple-900 
        bg-pink-100 bg-pink-200 bg-pink-300 bg-pink-400 bg-pink-500 bg-pink-600 bg-pink-700 bg-pink-800 bg-pink-900
        bg-yellow-100 bg-yellow-200 bg-yellow-300 bg-yellow-400 bg-yellow-500 bg-yellow-600 bg-yellow-700 bg-yellow-800 bg-yellow-900
        "> </div>
        <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-100 transform"
          x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
          x-transition:leave="transition ease-in duration-75 transform" x-transition:leave-start="opacity-100 scale-100"
          x-transition:leave-end="opacity-0 scale-95" class="border border-gray-300 origin-top-right absolute right-0 top-full mt-2 rounded-md shadow-lg">
          <div class="rounded-md bg-white shadow-xs p-2">
            <div class="flex">
              <template x-for="color in colors">
                <div class="">
                  <template x-for="variant in variants">
                    <div @click="selectColor(color,variant)" class="cursor-pointer w-6 h-6 rounded-full mx-1 my-1" :class="`bg-${color}-${variant}`"></div>
                  </template>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  function app() {
      return {
        colors: ['red', 'pink', 'purple', 'indigo', 'blue', 'yellow', 'teal', 'green'],
        variants: [100, 200, 300, 400, 500, 600, 700, 800, 900],
        currentColor: '',
        iconColor: '',
        isOpen: false,
        pColor: '',
        pVariant: 100,
        initColor () {
          this.pColor = '{{$pColor}}'
          this.pVariant = {{$pVariant}}
          this.currentColor = this.pColor + '-' + this.pVariant
          if (this.pVariant < 500) {
            this.setIconBlack()
          }
          else {
            this.setIconWhite()
          }
        },
        setIconWhite () {
          this.iconColor = 'text-white'
        },
        setIconBlack () {
          this.iconColor = 'text-black'
        },
        selectColor (color, variant) {
          this.currentColor = color + '-' + variant
          if (variant < 500) {
            this.setIconBlack()
          }
          else {
            this.setIconWhite()
          }
        }
      }
  }
</script>