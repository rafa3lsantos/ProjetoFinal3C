import axios from "axios";

const HttpService = axios.create({
  baseURL: "http://127.0.0.1:8000/api/",
  headers: {
    "Content-type": "application/json",
    Accept: "application/json"
  },
});

export default HttpService;
