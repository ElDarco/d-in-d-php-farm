import HttpClient from "@/providers/clients/http-client";
import {AxiosRequestConfig} from "axios";

export class MockServerApi extends HttpClient {
  public createNSpace(
    name: string,
    proxyToUrl: string,
    useProxy: boolean,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.post('/api/v1/nspace', {
        "name": name,
        "proxyToUrl": proxyToUrl,
        "useProxy": useProxy
      })
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    })
  }

  public async getNSpaceInfo(
    nspace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.get('/api/v1/nspace/' + nspace.id)
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    });
  }

  public createNSettings(
    nSpace: NSpace | NSpaceInCache,
    body: string,
    uri: string,
    method: string,
    code: number,
    queryString: string,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.post('/api/v1/nspace/' + nSpace.id + '/settings/add', {
        "body": body,
        "uri": uri,
        "method": method,
        "code": code,
        "headers": {},
        "queryString": queryString
      })
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    })
  }

  public clearNSettings(
    nSpace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.post('/api/v1/nspace/' + nSpace.id + '/settings/clear')
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    })
  }

  public deleteNSpace(
    nSpace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return new Promise((resolve, reject) => {
      this.delete('/api/v1/nspace/' + nSpace.id + '/')
        .then((response) => {
          if (successCallback !== undefined) {
            successCallback(response)
          }
          resolve(response)
        })
        .catch((error) => {
          if (failureCallback !== undefined) {
            failureCallback(error)
          }
          reject(error)
        })
        .finally(() => {
          if (doneCallback !== undefined) {
            doneCallback()
          }
        });
    })
  }

  protected beforeRequest(config: AxiosRequestConfig): AxiosRequestConfig {
    config.baseURL = process.env.VUE_APP_MOCK_SERVER_HOST_URL;

    return config;
  }
}