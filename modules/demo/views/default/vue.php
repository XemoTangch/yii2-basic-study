<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/2/27
 * Time: 16:11
 * Desc: vue
 */
$this->title = 'vue 示例';
?>

<h1 xmlns:v-bind="http://www.w3.org/1999/xhtml">vue 示例</h1>

<h3>声明式渲染</h3>

<h4>示例1</h4>
<div id="app">
    {{ message }}
</div>
<script type="application/javascript">
    var app = new Vue({
        el: '#app',
        data: {
            message: '开启我的vue项目'
        }
    })
</script>

<h4>示例2</h4>
<div id="app-2">
  <span v-bind:title="message">
    鼠标悬停几秒钟查看此处动态绑定的提示信息！
  </span>
</div>
<script type="application/javascript">
    var app2 = new Vue({
        el: '#app-2',
        data: {
            message: '页面加载于 ' + new Date().toLocaleString()
        }
    })
</script>

<h3>条件与循环</h3>

<h4>条件</h4>
<div id="app-3">
  <p v-if="seen">现在你看到我了</p>
</div>
<script type="text/javascript">
	var app3 = new Vue({
	  el: '#app-3',
	  data: {
	    seen: true
	  }
	})
</script>

<h4>循环</h4>
<div id="app-4">
  <ol>
    <li v-for="todo in todos">
      {{ todo.text }}
    </li>
  </ol>
</div>
<script type="text/javascript">
	var app4 = new Vue({
	  el: '#app-4',
	  data: {
	    todos: [
	      { text: '学习 JavaScript' },
	      { text: '学习 Vue' },
	      { text: '整个牛项目' }
	    ]
	  }
	})
</script>

<h3>处理用户的输入</h3>
<div id="app-5">
  <p>{{ message }}</p>
  <button v-on:click="reverseMessage">逆转消息</button>
</div>
<script type="text/javascript">
	var app5 = new Vue({
	  el: '#app-5',
	  data: {
	    message: 'Hello Vue.js!'
	  },
	  methods: {
	    reverseMessage: function () {
	      this.message = this.message.split('').reverse().join('')
	    }
	  }
	})
</script>

<h3>组件化应用构建</h3>
<div id="app-7">
  <ol>
    <!--
      现在我们为每个 todo-item 提供 todo 对象
      todo 对象是变量，即其内容可以是动态的。
      我们也需要为每个组件提供一个“key”，稍后再
      作详细解释。
    -->
    <todo-item
      v-for="item in groceryList"
      v-bind:todo="item"
      v-bind:key="item.id">
    </todo-item>
  </ol>
</div>
<script type="text/javascript">
	Vue.component('todo-item', {
	  props: ['todo'],
	  template: '<li>{{ todo.text }}</li>'
	})
	
	var app7 = new Vue({
	  el: '#app-7',
	  data: {
	    groceryList: [
	      { id: 0, text: '蔬菜' },
	      { id: 1, text: '奶酪' },
	      { id: 2, text: '随便其它什么人吃的东西' }
	    ]
	  }
	})
</script>
