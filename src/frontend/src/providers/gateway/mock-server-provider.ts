import {MockServerApi} from "@/providers/clients/mock-server-api";

export class MockServerProvider {
  protected mockServerApi = new MockServerApi();

  public createNewNSpace(
    name: string,
    proxyToUrl: string,
    useProxy: boolean,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return this.mockServerApi.createNSpace(name, proxyToUrl, useProxy, successCallback, failureCallback, doneCallback)
  }

  public async syncNSpace(
    nSpace: NSpace | NSpaceInCache,
    successCallback: Function | undefined = undefined,
    failureCallback: Function | undefined = undefined,
    doneCallback: Function | undefined = undefined
  ) {
    return await this.mockServerApi.getNSpaceInfo(nSpace, successCallback, failureCallback, doneCallback);
  }
}