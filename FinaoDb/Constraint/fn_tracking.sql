ALTER TABLE `fn_tracking`
  ADD CONSTRAINT `fk_track_trackedusrid` FOREIGN KEY (`tracked_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_track_trackerusrid` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_tracking_ibfk_1` FOREIGN KEY (`tracked_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_tracking_ibfk_2` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
