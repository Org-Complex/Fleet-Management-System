//Fields
const pendingRequestTable_Fields = ["Purpose","Status","DateOfTrip","TimeOfTrip","PickLocation","DropLocation"]
const ongoingRequestTable_Fields = ["Purpose","DateOfTrip","TimeOfTrip","PickLocation","DropLocation"]
const requestHistoryTable_Fields = ["Purpose","Status","DateOfTrip","TimeOfTrip","PickLocation","DropLocation"]

const requestsByMeStore = new Store(requestsByMe);
const ongoingRequestsStore = new Store(ongoingRequests);
const pastRequestsStore = new Store(pastRequests);


const CancelRequestAlertClose = new DisplayNextButton('CancelRequestAlert_Close');
const CancelRequestAlertCancel = new DisplayNextButton('CancelRequestAlert_Cancel');
const CancelRequestAlertConfirm = new DisplayNextButton('CancelRequestAlert_Confirm',{},[RemoveAllPopup])
const CancelRequestAlertPopup = new Popup('CancelRequestAlertPopup',[CancelRequestAlertClose,CancelRequestAlertCancel,CancelRequestAlertConfirm]);

const CancelAddedRequestAlertClose = new DisplayNextButton('CancelAddedRequestAlert_Close');
const CancelAddedRequestAlertCancel = new DisplayNextButton('CancelAddedRequestAlert_Cancel');
const CancelAddedRequestAlertConfirm = new DisplayNextButton('CancelAddedRequestAlert_Confirm',{},[ObjectCreate,BackendAccess('CancelRequest',ActionCreator([requestsByMeStore,pastRequestsStore],"DELETE&ADD")),RemoveAllPopup])
const CancelAddedRequestAlertPopup = new Popup('CancelAddedRequestAlertPopup',[CancelAddedRequestAlertClose,CancelAddedRequestAlertCancel,CancelAddedRequestAlertConfirm]);

const NewRequestPreviewClose = new DisplayAlertButton('NewRequestPreview_Close',CancelRequestAlertPopup)
const NewRequestPreviewEdit = new DisplayNextButton('NewRequestPreview_Edit')
const NewRequestPreviewConfirm = new DisplayNextButton('NewRequestPreview_Confirm',{},[BackendAccess('RequestAdd',ActionCreator([requestsByMeStore],"ADD"))])
const NewRequestPreviewPopup = new Popup('NewRequestPreviewPopup',[NewRequestPreviewClose,NewRequestPreviewConfirm,NewRequestPreviewEdit]);
//cancel request next setup

const VehicleRequestFormClose = new DisplayAlertButton('VehicleRequestForm_Close',CancelRequestAlertPopup)
const VehicleRequestFormCancel = new DisplayAlertButton('VehicleRequestForm_Cancel',CancelRequestAlertPopup)
const VehicleRequestFormSubmit = new ValidatorButton('VehicleRequestForm_Submit',NewRequestPreviewPopup,[ObjectCreate,FormValidate,DateValidator]);
const VehicleRequestFormPopup = new Popup('VehicleRequestForm',[VehicleRequestFormCancel,VehicleRequestFormClose,VehicleRequestFormSubmit],['click','keyup']);
NewRequestPreviewEdit.setNext(VehicleRequestFormPopup);

const OngoingRequestPreviewClose = new DisplayNextButton('OngoingRequestPreview_Close')
const OngoingRequestPreviewRequestCancel = new DisplayAlertButton('OngoingRequestPreviewRequestCancel',CancelAddedRequestAlertPopup)
const OngoingRequestPreviewPopup = new Popup('OngoingRequestPreviewPopup',[OngoingRequestPreviewClose,OngoingRequestPreviewRequestCancel]);

const PendingRequestPreviewClose = new DisplayNextButton('PendingRequestPreview_Close')
const PendingRequestPreviewRequestCancel = new DisplayAlertButton('PendingRequestPreviewRequestCancel',CancelAddedRequestAlertPopup)
const PendingRequestPreviewPopup = new Popup('PendingRequestPreviewPopup',[PendingRequestPreviewClose,PendingRequestPreviewRequestCancel]);

const RequestHistoryPreviewClose = new DisplayNextButton('RequestHistoryPreview_Close')
const RequestHistoryPreviewPopup = new Popup('RequestHistoryPreviewPopup',[RequestHistoryPreviewClose]);

const UserProfilePopupClose = new DisplayNextButton('UserProfilePopup_Close')
const UserProfilePopup = new Popup('UserProfilePopup',[UserProfilePopupClose]);


const NewRequestButton = new DOMButton('NewRequestButton',VehicleRequestFormPopup)
const UserProfileEditButton = new DOMButton('UserProfileEditButton',UserProfilePopup)
const pendingRequestTable = new DOMContainer('pendingRequestCard',pendingRequestTable_Fields,PendingRequestPreviewPopup,"RequestId",requestsByMeStore,"cardTemplate");
const ongoingRequestTable = new DOMContainer('ongoingRequestCard',ongoingRequestTable_Fields,OngoingRequestPreviewPopup,"RequestId",ongoingRequestsStore,"cardTemplate");
const requestHistoryTable = new DOMContainer('pastRequestCard',requestHistoryTable_Fields,RequestHistoryPreviewPopup,"RequestId",pastRequestsStore,"cardTemplate" );

const pendingRequestTab = new DOMTabContainer('PendingRequestsSecTab',pendingRequestTable);
const ongoingRequestTab = new DOMTabContainer('OngoingRequestsSecTab',ongoingRequestTable);
const requestHistoryTab = new DOMTabContainer('HistorySecTab',requestHistoryTable);

const pendingRequestTabButton = new SecondaryTabButton('PendingRequestsSecLink',pendingRequestTab);
const ongoingRequestTabButton = new SecondaryTabButton('OngoingRequestsSecLink',ongoingRequestTab);
const requestHistoryTabButton = new SecondaryTabButton('HistorySecLink',requestHistoryTab);

const requesterTab = new SecondaryTab('MyRequestsSecTab',[pendingRequestTabButton,ongoingRequestTabButton,requestHistoryTabButton],pendingRequestTabButton);
requesterTab.render();


requestsByMeStore.addObservers(pendingRequestTable)
ongoingRequestsStore.addObservers(ongoingRequestTable)
pastRequestsStore.addObservers(requestHistoryTable)
