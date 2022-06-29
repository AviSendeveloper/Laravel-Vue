<template>
    <div>
        <h1>This is example components</h1>
         <ul>
            <li><router-link :to="{ name: 'first' }" class="vueRoute">Summary</router-link></li>
            <li><router-link to="/" class="vueRoute active">Inbox</router-link></li>
        </ul>
        <router-view></router-view>
    </div>
</template>