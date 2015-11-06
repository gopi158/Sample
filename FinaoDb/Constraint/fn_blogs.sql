ALTER TABLE `fn_blogs`
  ADD CONSTRAINT `fk_blog_category` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_blog_userid` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_blogs_ibfk_1` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`),
  ADD CONSTRAINT `fn_blogs_ibfk_2` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_blogs_ibfk_3` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_blogs_ibfk_4` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`);
