ALTER TABLE `fn_trackingnotifications`
  ADD CONSTRAINT `fk_tracknoti_createdby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tracknoti_notifyaction` FOREIGN KEY (`notification_action`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tracknoti_trackerid` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tracknoti_updatedby` FOREIGN KEY (`updateby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_2` FOREIGN KEY (`notification_action`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_3` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_4` FOREIGN KEY (`updateby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
