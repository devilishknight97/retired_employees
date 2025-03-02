import axios from "axios";

axios.defaults.baseURL = "http://localhost:8000/api"; // Base API URL
axios.headers = {
    'Content-Type': 'application/json',
}

export default axios;
