import HttpClient from "@/providers/http-client";
import {AxiosRequestConfig} from "axios";

export class MockServerApi extends HttpClient {
    //todo maybe add name
    public createNSpace() {
        return this.post('/api/v1/nspace')
    }

    protected beforeRequest(config: AxiosRequestConfig): AxiosRequestConfig {
        config.baseURL = process.env.VUE_APP_MOCK_SERVER_HOST_URL;

        return config;
    }
}