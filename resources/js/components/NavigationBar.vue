<template>
    <nav class="bg-blue-500 p-4 text-white flex justify-between">
        <div class="text-lg font-bold">Retired Employees</div>
        <ul class="flex space-x-4">
            <li><router-link to="/" class="hover:underline">Home</router-link></li>
            <li><router-link to="/employees" class="hover:underline">Employees</router-link></li>
            <li><router-link to="/add-employee" class="hover:underline">Add Employee</router-link></li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "NavigationBar",
};
</script>
